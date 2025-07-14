import React, { useState } from "react";
import "./LoginRegister.css";
import { FaUser, FaLock, FaEnvelope } from "react-icons/fa";

const LoginRegister = () => {
  const [action, setAction] = useState("");

  const registerLink = () => {
    setAction("active");
  };

  const loginLink = () => {
    setAction("");
  };

  const backgroundStyle = {
    backgroundImage: "url('/images/photo_2025-05-15_09-10-12.jpg')",
    backgroundSize: "cover",
    backgroundPosition: "center",
  };

  return (
    <div className="login-page" style={backgroundStyle}>
      <div className={`wrapper ${action}`}>
        <div className="form-box login">
          <form action="">
            <h1>Login</h1>
            <div className="input-box">
              <input type="email" placeholder="Email" required />
              <FaEnvelope className="icon" />
            </div>

            <div className="input-box">
              <input type="password" placeholder="Password" required />
              <FaLock className="icon" />
            </div>

            <div className="remember-forget">
              <label htmlFor="">
                <input type="checkbox" />
                Remember me
              </label>
              <a href="#">forget passowrd?</a>
            </div>

            <button type="submit">Login</button>

            <div className="register-link">
              <p>
                Don't have an account?
                <a href="#" onClick={registerLink}>
                  Register
                </a>
              </p>
            </div>
          </form>
        </div>

        <div className="form-box register">
          <form action="">
            <h1>Registration</h1>
            <div className="input-box">
              <input type="text" placeholder="username" required />
              <FaUser className="icon" />
            </div>

            <div className="input-box">
              <input type="email" placeholder="Email" required />
              <FaEnvelope className="icon" />
            </div>

            <div className="input-box">
              <input type="password" placeholder="Password" required />
              <FaLock className="icon" />
            </div>

            <div className="remember-forget">
              <label htmlFor="">
                <input type="checkbox" />I Agree To The Terms & conditions
              </label>
            </div>

            <button type="submit">Register</button>

            <div className="register-link">
              <p>
                Already have an account?
                <a href="#" onClick={loginLink}>
                  Login
                </a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default LoginRegister;
