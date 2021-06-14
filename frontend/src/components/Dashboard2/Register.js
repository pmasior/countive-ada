import React, {useState} from "react";
import {NavLink, withRouter} from "react-router-dom";
import {register} from "../../webservices/userAccount";

export const Register = withRouter((props) => {
  const [eMail, setEMail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [loginResult, setLoginResult] = useState(null);

  const handleSubmit = (e) => {
    e.preventDefault();
    if (password !== confirmPassword) {
        setLoginResult(false);
        return;
    }
    register(eMail, password, (status) => {
      if (status === 201) {
        props.history.push('/login');
      } else if (status === 400 || status === 422) {
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
                         to={`/login`}>
                  Login
                </NavLink>
              </li>
            </ul>
          </div>
        </nav>
        <main className="h-75 d-flex justify-content-center align-items-center">
          <form className="d-flex flex-column w-25 gap-2"
                onSubmit={handleSubmit}>
            <h1 className="align-self-center text-primary">Countive</h1>
            <h2 className="align-self-center text-secondary">Sign up</h2>
            <div className="form-floating">
              <input type="email" className={`form-control ${loginResult === false ? "is-invalid" : ""} `}
                     placeholder="example@example.com"
                     onChange={e => setEMail(e.target.value)} value={eMail}/>
              <label>Email</label>
            </div>
            <div className="form-floating">
              <input type="password" className={`form-control ${loginResult === false ? "is-invalid" : ""} `} placeholder="********"
                     onChange={e => setPassword(e.target.value)} value={password}/>
              <label>Password</label>
            </div>
            <div className="form-floating">
              <input type="password" className={`form-control ${loginResult === false ? "is-invalid" : ""} `} placeholder="********"
                     onChange={e => setConfirmPassword(e.target.value)} value={confirmPassword}/>
              <label>Confirm Password</label>
            </div>
            <div>
              <button type="submit" className="btn btn-lg btn-primary w-100">Sign up</button>
            </div>
          </form>
        </main>
      </div>
    </>

  )
})
